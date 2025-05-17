import '../entities/message.dart';

abstract class MessageRepository {
  Future<List<Message>> getChatMessages(int chatId);
  Future<Message> sendMessage({required int chatId, required int userId, required String message});
  Future<void> deleteMessage(int messageId);
}
