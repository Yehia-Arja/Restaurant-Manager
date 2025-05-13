import 'package:mobile/features/restaurant_selection/data/models/restaurant_model.dart';
import 'package:mobile/features/restaurant_selection/domain/entities/restaurant.dart';
import 'package:mobile/features/restaurant_selection/domain/repositories/restaurant_selection_repository.dart';
import 'package:mobile/features/restaurant_selection/data/datasources/restaurant_selection_remote.dart';

class RestaurantSelectionRepositoryImpl extends RestaurantSelectionRepository {
  final RestaurantSelectionRemote _remote;

  RestaurantSelectionRepositoryImpl(this._remote);

  @override
  Future<PaginatedRestaurants> getRestaurants({
    String? query,
    bool favoritesOnly = false,
    int page = 1,
  }) async {
    // 1) Fetch raw response
    final result = await _remote.getRestaurants(
      endpoint: 'common/restaurants',
      query: query,
      favoritesOnly: favoritesOnly,
      page: page,
    );

    final models = result['data'] as List<RestaurantModel>;
    final pagination = result['meta'] as Map<String, dynamic>;

    final restaurants =
        models
            .map(
              (m) => Restaurant(
                id: m.id,
                name: m.name,
                imageUrl: m.imageUrl,
                description: m.description,
                isFavorite: m.isFavorite,
              ),
            )
            .toList();

    final totalPages = int.tryParse(pagination['last_page'].toString()) ?? 1;

    return PaginatedRestaurants(restaurants: restaurants, totalPages: totalPages);
  }
}
