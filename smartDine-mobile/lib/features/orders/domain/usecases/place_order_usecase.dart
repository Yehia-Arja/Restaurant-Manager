import '../entities/order_entity.dart';
import '../repositories/order_repository.dart';

class PlaceOrderUseCase {
  final OrderRepository _repository;

  PlaceOrderUseCase(this._repository);

  Future<OrderEntity> call({required int productId, required int branchId, required int tableId}) {
    return _repository.placeOrder(productId: productId, branchId: branchId, tableId: tableId);
  }
}
