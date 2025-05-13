import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/features/products/domain/entities/product.dart';
import 'package:mobile/features/products/domain/usecases/get_product_detail_usecase.dart';
import 'package:mobile/features/products/presentation/bloc/product_detail_bloc.dart';
import 'package:mobile/features/products/presentation/bloc/product_detail_event.dart';
import 'package:mobile/features/products/presentation/bloc/product_detail_state.dart';
import 'package:mobile/features/products/presentation/screens/ar_view_screen.dart';
import 'package:mobile/features/orders/domain/usecases/place_order_usecase.dart';
import 'package:mobile/features/orders/presentation/bloc/order_bloc.dart';
import 'package:mobile/features/orders/presentation/widgets/confirm_order_button.dart';

class ProductDetailPage extends StatelessWidget {
  final Product? initialProduct;
  final int productId;

  const ProductDetailPage({Key? key, this.initialProduct, required this.productId})
    : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MultiBlocProvider(
      providers: [
        BlocProvider<ProductDetailBloc>(
          create:
              (ctx) =>
                  ProductDetailBloc(ctx.read<GetProductDetailUseCase>())
                    ..add(LoadProductDetail(productId)),
        ),
        BlocProvider<OrderBloc>(create: (ctx) => OrderBloc(ctx.read<PlaceOrderUseCase>())),
      ],
      child: BlocBuilder<ProductDetailBloc, ProductDetailState>(
        builder: (ctx, state) {
          if (initialProduct != null && state is DetailLoading) {
            return _buildDetailUI(context, initialProduct!);
          }
          if (state is DetailLoading) {
            return const Scaffold(body: Center(child: CircularProgressIndicator()));
          }
          if (state is DetailError) {
            return Scaffold(body: Center(child: Text(state.message)));
          }
          final p = (state as DetailLoaded).product;
          return _buildDetailUI(context, p);
        },
      ),
    );
  }

  Widget _buildDetailUI(BuildContext context, Product p) {
    final screenHeight = MediaQuery.of(context).size.height;
    const sheetInitial = 0.6;
    final imageHeight = screenHeight * (1 - sheetInitial);

    return Scaffold(
      body: Stack(
        children: [
          // image placeholder
          ClipRRect(
            borderRadius: const BorderRadius.vertical(bottom: Radius.circular(16)),
            child: Container(
              height: imageHeight,
              width: double.infinity,
              color: AppColors.placeholder,
              child: const Center(child: Icon(Icons.image, size: 48, color: Colors.white54)),
            ),
          ),

          // back button
          SafeArea(
            child: IconButton(
              icon: const Icon(Icons.chevron_left, size: 28, color: Colors.white),
              onPressed: () => Navigator.of(context).pop(),
            ),
          ),

          // details sheet
          DraggableScrollableSheet(
            initialChildSize: sheetInitial,
            minChildSize: 0.4,
            maxChildSize: 0.9,
            builder:
                (context, ctl) => Container(
                  decoration: const BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.vertical(top: Radius.circular(16)),
                  ),
                  child: ListView(
                    controller: ctl,
                    padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
                    children: [
                      // AR button
                      Align(
                        alignment: Alignment.centerLeft,
                        child: ActionChip(
                          backgroundColor: AppColors.accent,
                          label: const Text('View in AR', style: TextStyle(color: Colors.white)),
                          onPressed: () {
                            Navigator.of(context).push(
                              MaterialPageRoute(
                                builder: (_) => ARViewScreen(modelUrl: p.arModelUrl),
                              ),
                            );
                          },
                        ),
                      ),
                      const SizedBox(height: 12),

                      // title & price
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Text(p.name, style: Theme.of(context).textTheme.headlineSmall),
                          Text(
                            p.price,
                            style: Theme.of(
                              context,
                            ).textTheme.headlineSmall?.copyWith(color: AppColors.accent),
                          ),
                        ],
                      ),
                      const SizedBox(height: 8),

                      // delivery time
                      Row(
                        children: [
                          const Icon(Icons.access_time, size: 16, color: AppColors.accent),
                          const SizedBox(width: 6),
                          Text(p.timeToDeliver, style: Theme.of(context).textTheme.bodySmall),
                        ],
                      ),
                      const SizedBox(height: 16),

                      // ingredients
                      Text(
                        'Ingredients',
                        style: Theme.of(
                          context,
                        ).textTheme.headlineMedium?.copyWith(fontWeight: FontWeight.bold),
                      ),
                      const SizedBox(height: 4),
                      Text(p.ingredients, style: Theme.of(context).textTheme.bodyMedium),
                      const SizedBox(height: 16),

                      // description
                      Text('Details', style: Theme.of(context).textTheme.headlineMedium),
                      const SizedBox(height: 4),
                      Text(p.description, style: Theme.of(context).textTheme.bodyMedium),
                      const SizedBox(height: 24),

                      // confirm order
                      ConfirmOrderButton(productId: p.id),
                    ],
                  ),
                ),
          ),
        ],
      ),
    );
  }
}
