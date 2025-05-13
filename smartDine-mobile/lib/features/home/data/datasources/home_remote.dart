import 'package:dio/dio.dart';
import '../../domain/entities/home_data.dart';
import '../models/home_data_model.dart';

class HomeRemote {
  final Dio _dio;

  HomeRemote(this._dio);

  Future<HomeData> fetchHomeData({required int restaurantId, int? branchId}) async {
    try {
      final params = <String, dynamic>{if (branchId != null) 'restaurant_location_id': branchId};

      final response = await _dio.get('common/restaurants/$restaurantId', queryParameters: params);

      final model = HomeDataModel.fromJson(response.data as Map<String, dynamic>);

      return model.toEntity();
    } on DioException catch (e) {
      final message = (e.response?.data['message'] as String?) ?? e.message;
      throw Exception('Failed to fetch home data: $message');
    } catch (e) {
      throw Exception('Unexpected error fetching home data: $e');
    }
  }
}
