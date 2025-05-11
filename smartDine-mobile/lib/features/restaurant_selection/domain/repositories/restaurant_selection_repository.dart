import '../entities/restaurant.dart';

abstract class RestaurantSelectionRepository {
  Future<PaginatedRestaurants> getRestaurants({
    String? query,
    bool favoritesOnly = false,
    int page = 1,
  });
}

class PaginatedRestaurants {
  final List<Restaurant> restaurants;
  final int totalPages;

  PaginatedRestaurants({required this.restaurants, required this.totalPages});
}
