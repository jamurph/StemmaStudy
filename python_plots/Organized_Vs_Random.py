import pandas as pd
import numpy as np
import matplotlib.pyplot as plt


GREEN = '#28aa80'
BLUE = "#6ec4be"
DARK = '#192332'

plt.rcParams['text.color'] = DARK
plt.rcParams['axes.labelcolor'] = DARK
plt.rcParams['axes.edgecolor'] = DARK
plt.rcParams['xtick.color'] = DARK
plt.rcParams['ytick.color'] = DARK
plt.rcParams['legend.edgecolor'] = DARK
plt.rcParams['legend.frameon'] = False


j = {
        "Organized": [73, 106.1, 112],
        "Random": [20.6, 38.9, 52.8]
    }

df = pd.DataFrame(j)

index = np.arange(3)
bar_width = 0.35

fig, ax = plt.subplots()
organized = ax.bar(index, df["Organized"], bar_width,
                label="Organized", color= GREEN)

randomOrder = ax.bar(index+bar_width, df["Random"],
                 bar_width, label="Random Order", color=BLUE)

ax.set_xlabel('Number of Study Sessions')
ax.set_ylabel('Number of Words Recalled')
ax.set_title('Organization Facilitates Memory')
ax.set_xticks(index + bar_width / 2)
ax.set_xticklabels(["1", "2", "3"])
ax.axhline(y=112,label="Perfect Score", color=DARK, linestyle="--")

# Shrink current axis's height by 10% on the bottom
box = ax.get_position()
ax.set_position([box.x0, box.y0 + box.height * 0.1,
                 box.width, box.height * 0.9])

# Put a legend below current axis
ax.legend(loc='upper center', bbox_to_anchor=(0.5, -0.15), ncol=5)


plt.show()