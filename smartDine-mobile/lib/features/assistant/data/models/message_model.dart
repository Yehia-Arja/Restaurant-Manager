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
