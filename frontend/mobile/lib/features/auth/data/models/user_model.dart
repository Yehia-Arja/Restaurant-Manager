class UserModel {
    final int id;
    final String name;
    final String email;
    final String? dateOfBirth;
    final String? phoneNumber;

    UserModel({
        required this.id,
        required this.name,
        required this.email,
        this.dateOfBirth,
        this.phoneNumber,
    });

    factory UserModel.fromJson(Map<String, dynamic> json) {
        return UserModel(
            id: json['id'] as int,
            name: json['name'] as String,
            email: json['email'] as String,
            dateOfBirth: json['date_of_birth'] as String?,
            phoneNumber: json['phone_number'] as String?,
        );
    }
}
