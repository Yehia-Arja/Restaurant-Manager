import '../entities/restaurant.dart';
import '../repositories/restaurant_selection_repository.dart';

class GetRestaurantsUseCase {
  final RestaurantSelectionRepository _repo;
  GetRestaurantsUseCase(this._repo);

  Future<List<Restaurant>> call() {
    return _repo.getRestaurants();
  }
}
