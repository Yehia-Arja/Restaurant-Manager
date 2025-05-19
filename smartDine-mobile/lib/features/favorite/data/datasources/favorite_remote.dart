import 'package:dio/dio.dart';

class FavoriteRemote {
  final Dio _dio;
  FavoriteRemote(this._dio);

  Future<void> toggleFavorite({required int id, required String type}) async {
    try {
      print('om heteeee');
      final response = await _dio.post(
        'common/favorites',
        data: {'favoritable_id': id, 'favoritable_type': type},
      );

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
