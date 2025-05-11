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
      List<Restaurant> existingRestaurants = [];
      int currentPage = event.page;

      if (currentState is RestaurantSelectionLoaded && event.page > 1) {
        existingRestaurants = currentState.restaurants;
      } else {
        emit(RestaurantSelectionLoading());
      }

      final newRestaurants = await _getRestaurantsUseCase(
        query: event.query,
        favoritesOnly: event.favoritesOnly,
        page: event.page,
      );

      final combined = [...existingRestaurants, ...newRestaurants];
      final hasReachedEnd = newRestaurants.isEmpty;

      emit(
        RestaurantSelectionLoaded(
          restaurants: combined,
          currentPage: currentPage,
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

    final index = current.restaurants.indexWhere((r) => r.id == event.restaurantId);
    if (index == -1) return;

    // 1. Optimistically toggle favorite
    final original = current.restaurants[index];
    final updatedRestaurant = Restaurant(
      id: original.id,
      name: original.name,
      imageUrl: original.imageUrl,
      description: original.description,
      isFavorite: !original.isFavorite,
    );

    final updatedList = List<Restaurant>.from(current.restaurants);
    updatedList[index] = updatedRestaurant;

    emit(
      RestaurantSelectionLoaded(
        restaurants: updatedList,
        currentPage: current.currentPage,
        hasReachedEnd: current.hasReachedEnd,
      ),
    );

    // Try posting to backend
    try {
      await _toggleFavoriteUseCase(id: original.id, type: 'restaurant');
    } catch (_) {
      // Rollback on failure
      final rollbackList = List<Restaurant>.from(current.restaurants);
      rollbackList[index] = original;

      emit(
        RestaurantSelectionLoaded(
          restaurants: rollbackList,
          currentPage: current.currentPage,
          hasReachedEnd: current.hasReachedEnd,
        ),
      );
    }
  }
}
