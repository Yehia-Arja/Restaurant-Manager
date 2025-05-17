import '../../domain/entities/message.dart';

class MessageModel extends Message {
  const MessageModel({
    required int id,
    required String content,
    required String senderType,
    required DateTime createdAt,
  }) : super(id: id, content: content, senderType: senderType, createdAt: createdAt);

  factory MessageModel.fromJson(Map<String, dynamic> json) {
    return MessageModel(
      id: json['id'] as int,
      content: json['content'] as String,
      senderType: json['sender_type'] as String,
      createdAt: DateTime.parse(json['created_at'] as String),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'content': content,
      'sender_type': senderType,
      'created_at': createdAt.toIso8601String(),
    };
  }
}
