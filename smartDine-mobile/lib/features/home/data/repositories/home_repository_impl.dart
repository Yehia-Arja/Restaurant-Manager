import '../../domain/entities/home_data.dart';
import '../../domain/repositories/home_repository.dart';
import '../datasources/home_remote.dart';

class HomeRepositoryImpl implements HomeRepository {
  final HomeRemote _remote;

  HomeRepositoryImpl(this._remote);

  @override
  Future<HomeData> fetchHomeData({required int restaurantId, int? branchId}) {
    return _remote.fetchHomeData(restaurantId: restaurantId, branchId: branchId);
  }
}
