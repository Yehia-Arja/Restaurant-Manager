import 'package:dio/dio.dart';
import '../../domain/entities/product.dart';
import '../../domain/repositories/product_repository.dart';
import '../models/product_model.dart';

class ProductRemote {
  final Dio _dio;
  ProductRemote(this._dio);

  Future<PaginatedProducts> fetchProducts({
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
          'page': page,
          'per_page': pageSize,
          if (searchQuery != null && searchQuery.isNotEmpty) 'search': searchQuery,
          if (categoryId != null) 'category_id': categoryId,
          if (favoritesOnly) 'favorites': true,
        },
      );

      final raw = response.data;

      if (raw is! Map<String, dynamic>) {
        throw Exception('Invalid response format');
      }

      final rawList = raw['data'];
      if (rawList is! List<dynamic>) {
        throw Exception('Expected "data" to be a List, got ${rawList.runtimeType}');
      }

      final List<Product> products =
          rawList
              .map((e) => ProductModel.fromJson(Map<String, dynamic>.from(e)).toEntity())
              .toList();

      final pagination = raw['pagination'] as Map<String, dynamic>?;
      final lastPage = pagination?['last_page'] as int? ?? 1;

      return PaginatedProducts(products: products, totalPages: lastPage);
    } on DioException catch (e) {
      final msg = e.response?.data['message'] as String? ?? e.message ?? 'Unknown error';
      throw Exception('Failed to fetch products: $msg');
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
      final message = e.response?.data['message'] as String? ?? e.message ?? 'Unknown error';
      throw Exception('Failed to fetch product details: $message');
    } catch (e) {
      throw Exception('Unexpected error fetching product details: $e');
    }
  }
}
