import 'package:dio/dio.dart';

class FavoriteRemote {
  final Dio _dio;
  FavoriteRemote(this._dio);

  Future<void> toggleFavorite({required int id, required String type}) async {
    try {
      final response = await _dio.post('client/favorites/toggle', data: {'id': id, 'type': type});

      if (response.data['success'] != true) {
        throw Exception('Failed to toggle favorite');
      }
    } on DioException catch (error) {
      final message =
          (error.response?.data['message'] as String?) ?? error.message ?? 'Unknown error';
      throw Exception(message);
    }
  }
}
