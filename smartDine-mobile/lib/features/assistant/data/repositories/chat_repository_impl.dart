import '../../domain/entities/message.dart';
import '../../domain/repositories/chat_repository.dart';
import '../datasources/chat_remote.dart';

class ChatRepositoryImpl implements ChatRepository {
  final ChatRemoteDatasource remote;

  ChatRepositoryImpl(this.remote);

  @override
  Future<Message> sendMessage({required int branchId, required String message}) async {
    final result = await remote.sendMessage(branchId: branchId, message: message);
    return Message(content: result.content, isUser: false);
  }
}
