import 'package:mobile/features/restaurant_selection/domain/entities/restaurant.dart';

abstract class RestaurantSelectionRepository {
  Future<List<Restaurant>> getRestaurants({
    String? query,
    bool favoritesOnly = false,
    int page = 1,
  });
}
