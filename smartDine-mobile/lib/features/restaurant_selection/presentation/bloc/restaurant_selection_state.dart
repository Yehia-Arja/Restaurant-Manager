import '../../domain/entities/restaurant.dart';

abstract class RestaurantSelectionState {}

class RestaurantSelectionInitial extends RestaurantSelectionState {}

class RestaurantSelectionLoading extends RestaurantSelectionState {}

class RestaurantSelectionLoaded extends RestaurantSelectionState {
  final List<Restaurant> restaurants;
  final int currentPage;
  final bool hasReachedEnd;

  RestaurantSelectionLoaded({
    required this.restaurants,
    required this.currentPage,
    required this.hasReachedEnd,
  });
}

class RestaurantSelectionError extends RestaurantSelectionState {
  final String message;
  RestaurantSelectionError(this.message);
}
