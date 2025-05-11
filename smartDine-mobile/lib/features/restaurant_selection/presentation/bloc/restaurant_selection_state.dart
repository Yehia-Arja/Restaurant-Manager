import '../../domain/entities/restaurant.dart';

abstract class RestaurantSelectionState {}

class RestaurantSelectionInitial extends RestaurantSelectionState {}

class RestaurantSelectionLoading extends RestaurantSelectionState {}

class RestaurantSelectionLoaded extends RestaurantSelectionState {
  final List<Restaurant> restaurants;
  RestaurantSelectionLoaded(this.restaurants);
}

class RestaurantSelectionError extends RestaurantSelectionState {
  final String message;
  RestaurantSelectionError(this.message);
}
