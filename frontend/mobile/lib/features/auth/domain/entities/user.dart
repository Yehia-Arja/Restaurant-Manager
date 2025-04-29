class User {
    final int id;
    final String name;
    final String email;
    final String? dateOfBirth;
    final String? phoneNumber;

  User({
    required this.id,
    required this.name,
    required this.email,
    this.dateOfBirth,
    this.phoneNumber,
  });
}
