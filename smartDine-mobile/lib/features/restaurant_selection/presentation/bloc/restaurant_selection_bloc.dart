import 'package:bloc/bloc.dart';
import 'restaurant_selection_event.dart';
import 'restaurant_selection_state.dart';
import '../../domain/usecases/get_restaurants_usecase.dart';
import '../../domain/entities/restaurant.dart';

class RestaurantSelectionBloc extends Bloc<RestaurantSelectionEvent, RestaurantSelectionState> {
  final GetRestaurantsUseCase _getRestaurantsUseCase;
  bool _isFetching = false;

  RestaurantSelectionBloc(this._getRestaurantsUseCase) : super(RestaurantSelectionInitial()) {
    on<FetchRestaurantsRequested>(_onFetchRestaurantsRequested);
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

      // Only keep old restaurants if we're paginating
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
}
