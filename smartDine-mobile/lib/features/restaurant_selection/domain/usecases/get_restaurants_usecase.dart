import '../entities/restaurant.dart';
import '../repositories/restaurant_selection_repository.dart';

class GetRestaurantsUsecase {
  final RestaurantSelectionRepository _repo;
  GetRestaurantsUsecase(this._repo);

  Future<List<Restaurant>> call() {
    return _repo.getRestaurants();
  }
}
