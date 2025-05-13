import '../entities/home_data.dart';

abstract class HomeRepository {
  Future<HomeData> fetchHomeData({required int restaurantId, int? branchId});
}
