import '../../domain/entities/restaurant.dart';
import '../../domain/repositories/restaurant_selection_repository.dart';
import '../datasources/restaurant_selection_remote.dart';

class RestaurantSelectionRepositoryImpl extends RestaurantSelectionRepository {
  final RestaurantSelectionRemote _remote;

  RestaurantSelectionRepositoryImpl(this._remote);

  @override
  Future<PaginatedRestaurants> getRestaurants({
    String? query,
    bool favoritesOnly = false,
    int page = 1,
  }) async {
    final Map<String, dynamic> result = await _remote.getRestaurants(
      endpoint: 'common/restaurants',
      query: query,
      favoritesOnly: favoritesOnly,
      page: page,
    );

    final dataList = result['data'] as List<dynamic>? ?? [];
    final meta = result['meta'] as Map<String, dynamic>? ?? {};

    final restaurants =
        dataList.map<Restaurant>((dynamic item) {
          final map = Map<String, dynamic>.from(item as Map);
          return Restaurant(
            id: int.parse(map['id'].toString()),
            name: map['name']?.toString() ?? '',
            imageUrl: map['image_url']?.toString() ?? '',
            description: map['description']?.toString(),
            isFavorite: map['is_favorite'] == true,
          );
        }).toList();

    final totalPages = int.tryParse(meta['last_page']?.toString() ?? '') ?? 1;

    return PaginatedRestaurants(restaurants: restaurants, totalPages: totalPages);
  }
}
