import '../repositories/message_repository.dart';

class DeleteMessage {
  final MessageRepository repository;

  DeleteMessage(this.repository);

  Future<void> call(int messageId) {
    return repository.deleteMessage(messageId);
  }
}
