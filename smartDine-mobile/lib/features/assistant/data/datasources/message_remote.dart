import 'package:dio/dio.dart';
import '../models/message_model.dart';

class MessageRemote {
  final Dio dio;

  MessageRemote(this.dio);

  Future<MessageModel> sendMessage({
    required int restaurantLocationId,
    required String message,
  }) async {
    try {
      final response = await dio.post(
        'common/chat',
        data: {'restaurant_location_id': restaurantLocationId, 'message': message},
      );

      final data = response.data['data']['message'];

      return MessageModel.fromJson(data);
    } catch (e) {
      throw Exception('Failed to send message: $e');
    }
  }

  Future<void> deleteMessage(int messageId) async {
    try {
      await dio.delete('common/chat/$messageId');
    } catch (e) {
      throw Exception('Failed to delete message: $e');
    }
  }
}
