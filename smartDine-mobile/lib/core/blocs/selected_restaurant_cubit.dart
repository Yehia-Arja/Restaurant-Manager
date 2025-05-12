// lib/core/blocs/selected_restaurant_cubit.dart
import 'package:bloc/bloc.dart';

// Holds the currently selected restaurant ID
typedef NullableInt = int?;

class SelectedRestaurantCubit extends Cubit<NullableInt> {
  SelectedRestaurantCubit() : super(null);

  // Call this when a restaurant is tapped
  void select(int id) => emit(id);
}
