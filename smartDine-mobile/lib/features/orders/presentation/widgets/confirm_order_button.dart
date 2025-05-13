import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/features/orders/presentation/bloc/order_bloc.dart';
import 'package:mobile/features/orders/presentation/bloc/order_event.dart';
import 'package:mobile/features/orders/presentation/bloc/order_state.dart';
import 'package:mobile/features/tables/domain/usecases/get_tables_usecase.dart';

class ConfirmOrderButton extends StatelessWidget {
  final int productId;

  const ConfirmOrderButton({super.key, required this.productId});

  @override
  Widget build(BuildContext context) {
    return BlocConsumer<OrderBloc, OrderState>(
      listener: (context, state) {
        if (state is OrderSuccess) {
          ScaffoldMessenger.of(
            context,
          ).showSnackBar(const SnackBar(content: Text('Order placed successfully!')));
        } else if (state is OrderFailure) {
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(state.message)));
        }
      },
      builder: (context, state) {
        return SizedBox(
          width: double.infinity,
          height: 48,
          child: ElevatedButton(
            onPressed:
                state is OrderInProgress
                    ? null
                    : () async {
                      final branchId = context.read<SelectedRestaurantCubit>().state;
                      if (branchId == null) return;

                      final tables = await context.read<GetTablesUseCase>()(branchId);

                      int? selectedTableId;

                      final result = await showDialog<int>(
                        context: context,
                        builder: (ctx) {
                          return StatefulBuilder(
                            builder: (context, setState) {
                              return AlertDialog(
                                title: const Text('Which table are you on?'),
                                content: DropdownButton<int>(
                                  isExpanded: true,
                                  value: selectedTableId,
                                  hint: const Text('Select table'),
                                  items:
                                      tables.map((t) {
                                        return DropdownMenuItem<int>(
                                          value: t.id, // Send ID
                                          child: Text('Table ${t.number} (Floor ${t.floor})'),
                                        );
                                      }).toList(),
                                  onChanged: (val) => setState(() => selectedTableId = val),
                                ),
                                actions: [
                                  TextButton(
                                    onPressed: () => Navigator.of(ctx).pop(),
                                    child: const Text('Cancel'),
                                  ),
                                  TextButton(
                                    onPressed:
                                        selectedTableId != null
                                            ? () => Navigator.of(ctx).pop(selectedTableId)
                                            : null,
                                    child: const Text('Confirm'),
                                  ),
                                ],
                              );
                            },
                          );
                        },
                      );

                      if (result != null) {
                        context.read<OrderBloc>().add(
                          PlaceOrderRequested(
                            productId: productId,
                            branchId: branchId,
                            tableId: result,
                          ),
                        );
                      }
                    },
            child:
                state is OrderInProgress
                    ? const SizedBox(
                      width: 24,
                      height: 24,
                      child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                    )
                    : const Text('Confirm Order'),
          ),
        );
      },
    );
  }
}
