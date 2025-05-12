import 'package:dio/dio.dart';
import '../../domain/entities/category.dart';
import '../models/category_model.dart';

class CategoryRemote {
  final Dio _dio;
  CategoryRemote(this._dio);

  Future<List<Category>> fetchCategories(int branchId) async {
    try {
      final response = await _dio.get(
        'common/categories',
        queryParameters: {'restaurant_location_id': branchId},
      );
      final rawList = response.data['data'] as List<dynamic>;
      return rawList
          .map((e) => CategoryModel.fromJson(e as Map<String, dynamic>).toEntity())
          .toList();
    } on DioException catch (e) {
      final message = e.response?.data['message'] as String? ?? e.message;
      throw Exception('Failed to fetch categories: $message');
    } catch (e) {
      throw Exception('Unexpected error fetching categories: $e');
    }
  }
}
