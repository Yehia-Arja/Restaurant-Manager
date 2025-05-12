import 'package:dio/dio.dart';
import '../model/order_model.dart';

class OrdersRemote {
  final Dio _dio;
  OrdersRemote(this._dio);

  Future<OrderModel> placeOrder({
    required int productId,
    required int branchId,
    required int tableNumber,
  }) async {
    try {
      final response = await _dio.post(
        'client/orders',
        data: {
          'product_id': productId,
          'restaurant_location_id': branchId,
          'table_number': tableNumber,
        },
      );
      final json = response.data['data'] as Map<String, dynamic>;
      return OrderModel.fromJson(json);
    } on DioException catch (e) {
      final message = e.response?.data['message'] as String? ?? e.message;
      throw Exception('Failed to place order: $message');
    } catch (e) {
      throw Exception('Unexpected error placing order: $e');
    }
  }
}
