import '../../domain/entities/table_entity.dart';

class TableModel extends TableEntity {
  TableModel({
    required int id,
    required bool isOccupied,
    required int floor,
    required double x,
    required double y,
  }) : super(id: id, isOccupied: isOccupied, floor: floor, x: x, y: y);

  factory TableModel.fromJson(Map<String, dynamic> json) {
    final pos = json['position'] as Map<String, dynamic>;
    return TableModel(
      id: json['id'] as int,
      isOccupied: (json['is_occupied'] as bool?) ?? false,
      floor: json['floor'] as int,
      x: (pos['x'] as num).toDouble(),
      y: (pos['y'] as num).toDouble(),
    );
  }

  TableEntity toEntity() {
    return TableEntity(id: id, isOccupied: isOccupied, floor: floor, x: x, y: y);
  }
}
