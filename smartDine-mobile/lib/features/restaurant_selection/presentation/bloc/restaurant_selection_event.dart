abstract class RestaurantSelectionEvent {}

class FetchRestaurantsRequested extends RestaurantSelectionEvent {
  final int page;
  final String? query;
  final bool favoritesOnly;

  FetchRestaurantsRequested({required this.page, this.query, this.favoritesOnly = false});
}
