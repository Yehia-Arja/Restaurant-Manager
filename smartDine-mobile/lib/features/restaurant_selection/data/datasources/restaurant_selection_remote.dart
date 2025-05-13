import 'package:dio/dio.dart';
import 'package:mobile/features/restaurant_selection/data/models/restaurant_model.dart';

class RestaurantSelectionRemote {
  final Dio _dio;
  RestaurantSelectionRemote(this._dio);

  /// Fetches a paginated list of restaurants.
  /// Expects the JSON to look like:
  /// {
  ///   "data": [ { …restaurant objects… } ],
  ///   "pagination": { "current_page": 1, "last_page": 5, ... }
  /// }
  Future<Map<String, dynamic>> getRestaurants({
    required String endpoint,
    String? query,
    bool favoritesOnly = false,
    int page = 1,
  }) async {
    try {
      final resp = await _dio.get(
        endpoint,
        queryParameters: {
          if (query != null) 'search': query,
          'favorites': favoritesOnly,
          'page': page,
        },
      );

      final raw = resp.data;
      if (raw is! Map<String, dynamic>) {
        throw Exception('Expected top-level JSON object, got ${raw.runtimeType}');
      }

      final rawList = raw['data'];
      if (rawList is! List<dynamic>) {
        throw Exception('Expected "data" to be a List, got ${rawList.runtimeType}');
      }

      final data =
          rawList.map((e) {
            if (e is Map<String, dynamic>) {
              return RestaurantModel.fromJson(e);
            }
            if (e is Map) {
              return RestaurantModel.fromJson(Map<String, dynamic>.from(e));
            }
            throw Exception('Invalid item in "data": ${e.runtimeType}');
          }).toList();

      final pagRaw = raw['pagination'];
      if (pagRaw is! Map<String, dynamic>) {
        throw Exception('Expected "pagination" to be a Map, got ${pagRaw.runtimeType}');
      }
      final meta = Map<String, dynamic>.from(pagRaw);

      return {'data': data, 'meta': meta};
    } on DioException catch (error) {
      final msg = (error.response?.data['message'] as String?) ?? error.message ?? 'Unknown error';
      throw Exception(msg);
    }
  }
}
