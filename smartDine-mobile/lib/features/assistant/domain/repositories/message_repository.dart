import '../entities/message.dart';

abstract class MessageRepository {
  Future<List<Message>> getChatMessages(int restaurantLocationId);
  Future<Message> sendMessage({required int restaurantLocationId, required String message});
  Future<void> deleteMessage(int messageId);
}
