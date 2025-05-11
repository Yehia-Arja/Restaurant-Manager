import 'package:bloc/bloc.dart';
import 'restaurant_selection_event.dart';
import 'restaurant_selection_state.dart';
import '../../domain/usecases/get_restaurants_usecase.dart';

class RestaurantSelectionBloc extends Bloc<RestaurantSelectionEvent, RestaurantSelectionState> {
  final GetRestaurantsUseCase _getRestaurantsUseCase;

  RestaurantSelectionBloc(this._getRestaurantsUseCase) : super(RestaurantSelectionInitial()) {
    on<FetchRestaurantsRequested>(_onFetchRestaurantsRequested);
  }

  Future<void> _onFetchRestaurantsRequested(
    FetchRestaurantsRequested event,
    Emitter<RestaurantSelectionState> emit,
  ) async {
    emit(RestaurantSelectionLoading());
    try {
      final restaurants = await _getRestaurantsUseCase();
      emit(RestaurantSelectionLoaded(restaurants));
    } catch (e) {
      emit(RestaurantSelectionError(e.toString()));
    }
  }
}
