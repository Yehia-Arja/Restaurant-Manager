import 'package:mobile/features/assistant/domain/entities/message.dart';
import 'package:mobile/features/assistant/domain/repositories/message_repository.dart';
import 'package:mobile/features/assistant/data/datasources/chat_remote.dart';
import 'package:mobile/features/assistant/data/datasources/message_remote.dart';

class MessageRepositoryImpl implements MessageRepository {
  final ChatRemote chatRemote;
  final MessageRemote messageRemote;

  MessageRepositoryImpl({required this.chatRemote, required this.messageRemote});

  @override
  Future<List<Message>> getChatMessages(int restaurantLocationId) {
    return chatRemote.getChatHistory(restaurantLocationId: restaurantLocationId);
  }

  @override
  Future<Message> sendMessage({required int restaurantLocationId, required String message}) {
    return messageRemote.sendMessage(restaurantLocationId: restaurantLocationId, message: message);
  }

  @override
  Future<void> deleteMessage(int messageId) {
    return messageRemote.deleteMessage(messageId);
  }
}
