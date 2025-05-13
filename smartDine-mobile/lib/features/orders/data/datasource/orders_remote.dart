import 'package:dio/dio.dart';
import '../models/order_model.dart';

class OrdersRemote {
  final Dio _dio;
  OrdersRemote(this._dio);

  Future<OrderModel> placeOrder({
    required int productId,
    required int branchId,
    required int tableNumber,
  }) async {
    final response = await _dio.post(
      'client/orders',
      data: {
        'product_id': productId,
        'restaurant_location_id': branchId,
        'table_number': tableNumber,
      },
    );
    return OrderModel.fromJson(response.data['data'] as Map<String, dynamic>);
  }
}
