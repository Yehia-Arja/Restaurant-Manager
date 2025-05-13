import 'package:dio/dio.dart';
import '../../domain/entities/product.dart';
import '../models/product_model.dart';

class ProductRemote {
  final Dio _dio;
  ProductRemote(this._dio);

  Future<List<Product>> fetchProducts(int branchId, String? searchQuery, int? categoryId) async {
    try {
      final response = await _dio.get(
        'common/products',
        queryParameters: {
          'restaurant_location_id': branchId,
          if (searchQuery != null && searchQuery.isNotEmpty) 'search': searchQuery,
          if (categoryId != null) 'category_id': categoryId,
        },
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

  Future<Product> fetchProductById(int productId) async {
    try {
      final response = await _dio.get('common/products/$productId');
      final json = response.data['data'] as Map<String, dynamic>;
      return ProductModel.fromJson(json).toEntity();
    } on DioException catch (e) {
      final message = e.response?.data['message'] as String? ?? e.message;
      throw Exception('Failed to fetch product details: $message');
    } catch (e) {
      throw Exception('Unexpected error fetching product details: $e');
    }
  }
}
