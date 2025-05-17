import '../entities/message.dart';
import '../repositories/message_repository.dart';

class GetChatHistory {
  final MessageRepository repository;

  GetChatHistory(this.repository);

  Future<List<Message>> call(int restaurantLocationId) {
    return repository.getChatMessages(restaurantLocationId);
  }
}
