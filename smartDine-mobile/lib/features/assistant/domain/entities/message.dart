class Message {
  final int id;
  final String content;
  final String senderType;
  final DateTime createdAt;

  const Message({
    required this.id,
    required this.content,
    required this.senderType,
    required this.createdAt,
  });
}
