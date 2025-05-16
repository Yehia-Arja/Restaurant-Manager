import '../entities/message.dart';
import '../repositories/chat_repository.dart';

class SendMessageUseCase {
  final ChatRepository repository;

  SendMessageUseCase(this.repository);

  Future<Message> call({required int branchId, required String message}) async {
    return await repository.sendMessage(branchId: branchId, message: message);
  }
}
