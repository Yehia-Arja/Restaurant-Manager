import '../entities/message.dart';
import '../repositories/message_repository.dart';

class SendMessage {
  final MessageRepository repository;

  SendMessage(this.repository);

  Future<Message> call({required int restaurantLocationId, required String message}) {
    return repository.sendMessage(restaurantLocationId: restaurantLocationId, message: message);
  }
}
