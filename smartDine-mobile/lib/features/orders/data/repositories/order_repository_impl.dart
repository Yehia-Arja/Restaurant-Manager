import '../../domain/entities/order_entity.dart';
import '../../domain/repositories/order_repository.dart';
import '../datasource/orders_remote.dart';

class OrderRepositoryImpl implements OrderRepository {
  final OrdersRemote _remote;
  OrderRepositoryImpl(this._remote);

  @override
  Future<OrderEntity> placeOrder({
    required int productId,
    required int branchId,
    required int tableNumber,
  }) async {
    final model = await _remote.placeOrder(
      productId: productId,
      branchId: branchId,
      tableNumber: tableNumber,
    );
    return model;
  }
}
