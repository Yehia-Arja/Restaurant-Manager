class UserModel {
  final String firstName;
  final String lastName;
  final String email;
  final int userTypeId;

  UserModel({
    required this.firstName,
    required this.lastName,
    required this.email,
    required this.userTypeId,
  });

  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      firstName: json['first_name'] as String,
      lastName: json['last_name'] as String,
      email: json['email'] as String,
      userTypeId: json['user_type_id'] as int,
    );
  }
}
