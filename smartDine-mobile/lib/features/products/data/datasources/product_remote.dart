import 'package:dio/dio.dart';
import '../../domain/entities/product.dart';
import '../models/product_model.dart';

class ProductRemote {
  final Dio _dio;
  ProductRemote(this._dio);

  Future<List<Product>> fetchProducts(int branchId) async {
    try {
      final response = await _dio.get(
        'common/products',
        queryParameters: {'restaurant_location_id': branchId},
      );
      final rawList =
          (response.data['data']['products'] as List<dynamic>).cast<Map<String, dynamic>>();
      return rawList.map((json) => ProductModel.fromJson(json).toEntity()).toList();
    } on DioException catch (e) {
      final message = e.response?.data['message'] as String? ?? e.message;
      throw Exception('Failed to fetch products: $message');
    } catch (e) {
      throw Exception('Unexpected error fetching products: $e');
    }
  }
}
