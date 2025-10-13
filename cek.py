import tempfile, os
from pyrouge import Rouge155

reference = "The cat was found under the bed."
candidate = "The cat was under the bed."

# Simpan ke file sementara
tmp_dir = tempfile.mkdtemp()
ref_path = os.path.join(tmp_dir, "ref.001.txt")
sys_path = os.path.join(tmp_dir, "sys.001.txt")

with open(ref_path, "w") as f: f.write(reference)
with open(sys_path, "w") as f: f.write(candidate)

r = Rouge155()
r.system_dir = tmp_dir
r.model_dir = tmp_dir
r.system_filename_pattern = 'sys.(\d+).txt'
r.model_filename_pattern = 'ref.#ID#.txt'

output = r.convert_and_evaluate(system_id='001', options="-a -c 95 -m -n 2 -w 1.2 -2 4 -u")
print(output)
