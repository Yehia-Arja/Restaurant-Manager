import 'package:mobile/features/home/domain/entities/branch.dart';

class BranchModel extends Branch {
  BranchModel({
    required int id,
    required String locationName,
    required String address,
    required String city,
    required int restaurantId,
  }) : super(
         id: id,
         locationName: locationName,
         address: address,
         city: city,
         restaurantId: restaurantId,
       );

  factory BranchModel.fromJson(Map<String, dynamic> json) {
    return BranchModel(
      id: json['id'] as int,
      locationName: json['location_name'] as String,
      address: json['address'] as String,
      city: json['city'] as String,
      restaurantId: json['restaurant_id'] as int,
    );
  }
}
