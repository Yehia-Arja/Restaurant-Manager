import 'package:dio/dio.dart';
import 'package:mobile/features/restaurant_selection/data/models/restaurant_model.dart';

class RestaurantSelectionRemote {
  final Dio _dio;
  RestaurantSelectionRemote(this._dio);

  Future<Map<String, dynamic>> getRestaurants({
    required String endpoint,
    String? query,
    bool favoritesOnly = false,
    int page = 1,
  }) async {
    try {
      final response = await _dio.get(
        endpoint,
        queryParameters: {
          if (query != null) 'search': query,
          'favorites': favoritesOnly,
          'page': page,
        },
      );

      final raw = response.data as Map<String, dynamic>;

      final dataList =
          (raw['data'] as List<dynamic>?)
              ?.map((e) => RestaurantModel.fromJson(e as Map<String, dynamic>))
              .toList() ??
          <RestaurantModel>[];

      final meta = (raw['meta'] as Map<String, dynamic>?) ?? {};

      return {'data': dataList, 'meta': meta};
    } on DioException catch (error) {
      final message =
          (error.response?.data['message'] as String?) ?? error.message ?? 'Unknown error';
      throw Exception(message);
    }
  }
}
