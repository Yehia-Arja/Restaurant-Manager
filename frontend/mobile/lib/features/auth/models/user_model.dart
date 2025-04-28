class UserModel {
    final int id;
    final String name;
    final String email;
    final String? date_of_birth;
    final String? phone_number;

    UserModel({
        required this.id,
        required this.name,
        required this.email,
        this.date_of_birth,
        this.phone_number,
    });

    factory UserModel.fromJson(Map<String, dynamic> json) {
        return UserModel(
            id: json['id'] as int,
            name: json['name'] as String,
            email: json['email'] as String,
            date_of_birth: json['date_of_birth'] as String?,
            phone_number: json['phone_number'] as String?,
        );
    }
}
