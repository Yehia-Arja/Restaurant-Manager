import '../entities/message.dart';

abstract class ChatRepository {
  Future<Message> sendMessage({required int branchId, required String message});
}
