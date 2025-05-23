import '../repositories/restaurant_selection_repository.dart';

class GetRestaurantsUseCase {
  final RestaurantSelectionRepository _repo;
  GetRestaurantsUseCase(this._repo);

  Future<PaginatedRestaurants> call({String? query, bool favoritesOnly = false, int page = 1}) {
    return _repo.getRestaurants(query: query, favoritesOnly: favoritesOnly, page: page);
  }
}
