import 'package:bloc/bloc.dart';
import 'restaurant_selection_event.dart';
import 'restaurant_selection_state.dart';
import '../../domain/usecases/get_restaurants_usecase.dart';
import '../../domain/usecases/toggle_favorite_usecase.dart';
import '../../domain/entities/restaurant.dart';

class RestaurantSelectionBloc extends Bloc<RestaurantSelectionEvent, RestaurantSelectionState> {
  final GetRestaurantsUseCase _getRestaurantsUseCase;
  final ToggleFavoriteUseCase _toggleFavoriteUseCase;
  bool _isFetching = false;

  RestaurantSelectionBloc(this._getRestaurantsUseCase, this._toggleFavoriteUseCase)
    : super(RestaurantSelectionInitial()) {
    on<FetchRestaurantsRequested>(_onFetchRestaurantsRequested);
    on<ToggleFavoriteRequested>(_onToggleFavoriteRequested);
  }

  Future<void> _onFetchRestaurantsRequested(
    FetchRestaurantsRequested event,
    Emitter<RestaurantSelectionState> emit,
  ) async {
    if (_isFetching) return;
    _isFetching = true;

    try {
      final currentState = state;
      List<Restaurant> existing = [];
      if (currentState is RestaurantSelectionLoaded && event.page > 1) {
        existing = currentState.restaurants;
      } else {
        emit(RestaurantSelectionLoading());
      }

      final paged = await _getRestaurantsUseCase(
        query: event.query,
        favoritesOnly: event.favoritesOnly,
        page: event.page,
      );

      final combined = [...existing, ...paged.restaurants];
      final hasReachedEnd = event.page >= paged.totalPages;

      emit(
        RestaurantSelectionLoaded(
          restaurants: combined,
          currentPage: event.page,
          totalPages: paged.totalPages,
          hasReachedEnd: hasReachedEnd,
        ),
      );
    } catch (e) {
      emit(RestaurantSelectionError(e.toString()));
    } finally {
      _isFetching = false;
    }
  }

  Future<void> _onToggleFavoriteRequested(
    ToggleFavoriteRequested event,
    Emitter<RestaurantSelectionState> emit,
  ) async {
    if (state is! RestaurantSelectionLoaded) return;
    final current = state as RestaurantSelectionLoaded;
    final idx = current.restaurants.indexWhere((r) => r.id == event.restaurantId);
    if (idx < 0) return;

    final original = current.restaurants[idx];
    final toggled = Restaurant(
      id: original.id,
      name: original.name,
      imageUrl: original.imageUrl,
      description: original.description,
      isFavorite: !original.isFavorite,
    );

    final updatedList = List<Restaurant>.from(current.restaurants)..[idx] = toggled;

    emit(
      RestaurantSelectionLoaded(
        restaurants: updatedList,
        currentPage: current.currentPage,
        totalPages: current.totalPages,
        hasReachedEnd: current.hasReachedEnd,
      ),
    );

    try {
      await _toggleFavoriteUseCase(id: original.id, type: 'restaurant');
    } catch (_) {
      // rollback
      updatedList[idx] = original;
      emit(
        RestaurantSelectionLoaded(
          restaurants: updatedList,
          currentPage: current.currentPage,
          totalPages: current.totalPages,
          hasReachedEnd: current.hasReachedEnd,
        ),
      );
    }
  }
}
