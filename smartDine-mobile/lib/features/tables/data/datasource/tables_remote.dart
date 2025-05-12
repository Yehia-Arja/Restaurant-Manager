import 'package:dio/dio.dart';
import '../../domain/entities/table_entity.dart';
import '../model/table_model.dart';

class TablesRemote {
  final Dio _dio;
  TablesRemote(this._dio);

  Future<List<TableEntity>> fetchTables(int branchId) async {
    try {
      final response = await _dio.get(
        'common/tables',
        queryParameters: {'restaurant_location_id': branchId},
      );
      final rawList = (response.data['data'] as List<dynamic>).cast<Map<String, dynamic>>();
      return rawList.map((json) => TableModel.fromJson(json).toEntity()).toList();
    } on DioException catch (e) {
      final message = e.response?.data['message'] as String? ?? e.message;
      throw Exception('Failed to fetch tables: $message');
    } catch (e) {
      throw Exception('Unexpected error fetching tables: $e');
    }
  }
}
