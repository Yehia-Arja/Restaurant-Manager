import 'package:mobile/features/restaurant_selection/domain/repositories/restaurant_selection_repository.dart';
import 'package:mobile/features/restaurant_selection/domain/entities/restaurant.dart';
import 'package:mobile/features/restaurant_selection/data/datasources/restaurant_selection_remote.dart';

class RestaurantSelectionRepositoryImpl extends RestaurantSelectionRepository {
  final RestaurantSelectionRemote _remote;

  RestaurantSelectionRepositoryImpl(this._remote);

  @override
  Future<List<Restaurant>> getRestaurants({
    String? query,
    bool favoritesOnly = false,
    int page = 1,
  }) async {
    final restaurantModels = await _remote.getRestaurants(
      endpoint: 'common/restaurants',
      query: query,
      favoritesOnly: favoritesOnly,
      page: page,
    );

    return restaurantModels
        .map(
          (model) => Restaurant(
            id: model.id,
            name: model.name,
            imageUrl: model.imageUrl,
            description: model.description,
          ),
        )
        .toList();
  }
}
