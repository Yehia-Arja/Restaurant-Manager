import '../../domain/entities/message.dart';

class MessageModel {
  final int id;
  final String content;
  final String senderType;
  final DateTime createdAt;

  MessageModel({
    required this.id,
    required this.content,
    required this.senderType,
    required this.createdAt,
  });

  factory MessageModel.fromJson(Map<String, dynamic> json) {
    return MessageModel(
      id: json['id'],
      content: json['content'],
      senderType: json['sender_type'],
      createdAt: DateTime.parse(json['created_at']),
    );
  }

  Message toEntity() {
    return Message(id: id, content: content, senderType: senderType, createdAt: createdAt);
  }
}
