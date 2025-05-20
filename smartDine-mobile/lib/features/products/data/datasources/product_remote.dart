import 'package:dio/dio.dart';
import '../../domain/entities/product.dart';
import '../../domain/repositories/product_repository.dart';
import '../models/product_model.dart';

class ProductRemote {
  final Dio _dio;
  ProductRemote(this._dio);

  Future<PaginatedProducts> fetchProducts({
    required int branchId,
    String? searchQuery,
    int? categoryId,
    bool favoritesOnly = false,
    int page = 1,
    int pageSize = 10,
  }) async {
    try {
      final response = await _dio.get(
        'common/products',
        queryParameters: {
          'restaurant_location_id': branchId,
          'page': page,
          'per_page': pageSize,
          if (searchQuery != null && searchQuery.isNotEmpty) 'search': searchQuery,
          if (categoryId != null) 'category_id': categoryId,
          if (favoritesOnly) 'favorite': 1,
        },
      );

      final rawList = response.data['data'] as List;
      final products =
          rawList
              .map((json) {
                try {
                  return ProductModel.fromJson(json).toEntity();
                } catch (e) {
                  return null;
                }
              })
              .whereType<Product>()
              .toList();

      return PaginatedProducts(products: products, totalPages: 1);
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
