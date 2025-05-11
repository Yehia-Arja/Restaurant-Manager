import 'package:mobile/features/restaurant_selection/domain/repositories/restaurant_selection_repository.dart';
import 'package:mobile/features/restaurant_selection/domain/entities/restaurant.dart';
import 'package:mobile/features/restaurant_selection/data/datasources/restaurant_selection_remote.dart';
import 'package:mobile/features/restaurant_selection/data/models/restaurant_model.dart';

class RestaurantSelectionRepositoryImpl extends RestaurantSelectionRepository {
  final RestaurantSelectionRemote _remote;

  RestaurantSelectionRepositoryImpl(this._remote);

  @override
  Future<List<Restaurant>> getRestaurants() async {
    final restaurantModels = await _remote.getRestaurants();
    return restaurantModels.map((model) => model.toEntity()).toList();
  }
}
