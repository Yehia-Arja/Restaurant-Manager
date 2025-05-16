class MessageModel {
  final String content;
  final String sender;

  MessageModel({required this.content, required this.sender});

  factory MessageModel.fromJson(Map<String, dynamic> json) {
    return MessageModel(content: json['content'], sender: json['sender']);
  }

  Map<String, dynamic> toJson() {
    return {'content': content, 'sender': sender};
  }
}
