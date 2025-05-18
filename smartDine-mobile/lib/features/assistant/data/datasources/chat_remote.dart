import 'package:dio/dio.dart';
import '../models/message_model.dart';

class ChatRemote {
  final Dio dio;

  ChatRemote(this.dio);

  Future<List<MessageModel>> getChatHistory({required int restaurantLocationId}) async {
    try {
      final response = await dio.get(
        'common/chat',
        queryParameters: {'restaurant_location_id': restaurantLocationId},
      );

      final data = response.data['data'] as List;
      return data.map((e) => MessageModel.fromJson(e)).toList();
    } catch (e) {
      throw Exception('Failed to fetch chat history: $e');
    }
  }
}
