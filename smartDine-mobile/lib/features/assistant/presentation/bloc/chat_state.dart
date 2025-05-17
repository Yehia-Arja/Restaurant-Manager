import 'package:equatable/equatable.dart';
import '../../domain/entities/message.dart';

class ChatState extends Equatable {
  final List<Message> messages;
  final bool loading;
  final String? error;

  const ChatState({required this.messages, this.loading = false, this.error});

  ChatState copyWith({List<Message>? messages, bool? loading, String? error}) {
    return ChatState(
      messages: messages ?? this.messages,
      loading: loading ?? this.loading,
      error: error,
    );
  }

  @override
  List<Object?> get props => [messages, loading, error];
}
