import '../entities/order_entity.dart';

abstract class OrderRepository {
  Future<OrderEntity> placeOrder({
    required int productId,
    required int branchId,
    required int tableId,
  });
}
