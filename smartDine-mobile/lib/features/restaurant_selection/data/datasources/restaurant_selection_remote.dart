import 'package:dio/dio.dart';
import 'package:mobile/features/restaurant_selection/data/models/restaurant_model.dart';

class RestaurantSelectionRemote {
  final Dio _dio;
  RestaurantSelectionRemote(this._dio);

  Future<List<RestaurantModel>> getRestaurants({
    required String endpoint,
    String? query,
    bool favoritesOnly = false,
    int page = 1,
  }) async {
    try {
      final response = await _dio.get(
        endpoint,
        queryParameters: {'search': query, 'favorites': favoritesOnly, 'page': page},
      );

      final data = response.data['data'] as List<dynamic>;

      return data.map((e) => RestaurantModel.fromJson(e as Map<String, dynamic>)).toList();
    } on DioException catch (error) {
      final message =
          (error.response?.data['message'] as String?) ?? error.message ?? 'Unknown error';
      throw Exception(message);
    }
  }
}
