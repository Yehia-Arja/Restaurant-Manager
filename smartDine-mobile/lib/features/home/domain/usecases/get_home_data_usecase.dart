import '../entities/home_data.dart';
import '../repositories/home_repository.dart';

class GetHomeDataUseCase {
  final HomeRepository repository;

  GetHomeDataUseCase(this.repository);

  Future<HomeData> call({required int restaurantId, int? branchId}) {
    return repository.fetchHomeData(restaurantId: restaurantId, branchId: branchId);
  }
}
